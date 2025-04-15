using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using dungeonMaster_final.Models;

namespace dungeonMaster_final.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class UnlockedSkillsController : ControllerBase
    {
        private readonly DungeonMaster _context;

        public UnlockedSkillsController(DungeonMaster context)
        {
            _context = context;
        }

        // GET: api/UnlockedSkills
        [HttpGet]
        public async Task<ActionResult<IEnumerable<UnlockedSkill>>> GetUnlockedSkills()
        {
            return await _context.UnlockedSkills
                //.Include(u => u.Player)
                .ToListAsync();
        }

        // GET: api/UnlockedSkills/5
        [HttpGet("{id}")]
        public async Task<ActionResult<UnlockedSkill>> GetUnlockedSkill(int id)
        {
            var unlockedSkill = await _context.UnlockedSkills
                //.Include(u => u.Player)
                .FirstOrDefaultAsync(u => u.UnlockedSkillId == id);

            if (unlockedSkill == null)
            {
                return NotFound();
            }

            return unlockedSkill;
        }

        // PUT: api/UnlockedSkills/5
        [HttpPut("{id}")]
        public async Task<IActionResult> PutUnlockedSkill(int id, UnlockedSkill unlockedSkill)
        {
            if (id != unlockedSkill.UnlockedSkillId)
            {
                return BadRequest();
            }

            _context.Entry(unlockedSkill).State = EntityState.Modified;

            try
            {
                await _context.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                if (!UnlockedSkillExists(id))
                {
                    return NotFound();
                }
                else
                {
                    throw;
                }
            }

            return NoContent();
        }

        // POST: api/UnlockedSkills
        [HttpPost]
        public async Task<ActionResult<UnlockedSkill>> PostUnlockedSkill(UnlockedSkill unlockedSkill)
        {
            _context.UnlockedSkills.Add(unlockedSkill);
            await _context.SaveChangesAsync();

            return CreatedAtAction("GetUnlockedSkill", new { id = unlockedSkill.UnlockedSkillId }, unlockedSkill);
        }

        // DELETE: api/UnlockedSkills/5
        [HttpDelete("{id}")]
        public async Task<IActionResult> DeleteUnlockedSkill(int id)
        {
            var unlockedSkill = await _context.UnlockedSkills.FindAsync(id);
            if (unlockedSkill == null)
            {
                return NotFound();
            }

            _context.UnlockedSkills.Remove(unlockedSkill);
            await _context.SaveChangesAsync();

            return NoContent();
        }

        private bool UnlockedSkillExists(int id)
        {
            return _context.UnlockedSkills.Any(e => e.UnlockedSkillId == id);
        }
    }
}