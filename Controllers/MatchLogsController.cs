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
    public class MatchLogsController : ControllerBase
    {
        private readonly DungeonMaster _context;

        public MatchLogsController(DungeonMaster context)
        {
            _context = context;
        }

        // GET: api/MatchLogs
        [HttpGet]
        public async Task<ActionResult<IEnumerable<MatchLog>>> GetMatchLogs()
        {
            return await _context.MatchLogs
                //.Include(m => m.Player)
                .ToListAsync();
        }

        // GET: api/MatchLogs/5
        [HttpGet("{id}")]
        public async Task<ActionResult<MatchLog>> GetMatchLog(int id)
        {
            var matchLog = await _context.MatchLogs
                //.Include(m => m.Player)
                .FirstOrDefaultAsync(m => m.MatchId == id);

            if (matchLog == null)
            {
                return NotFound();
            }

            return matchLog;
        }

        // PUT: api/MatchLogs/5
        [HttpPut("{id}")]
        public async Task<IActionResult> PutMatchLog(int id, MatchLog matchLog)
        {
            if (id != matchLog.MatchId)
            {
                return BadRequest();
            }

            _context.Entry(matchLog).State = EntityState.Modified;

            try
            {
                await _context.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                if (!MatchLogExists(id))
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

        // POST: api/MatchLogs
        [HttpPost]
        public async Task<ActionResult<MatchLog>> PostMatchLog(MatchLog matchLog)
        {
            _context.MatchLogs.Add(matchLog);
            await _context.SaveChangesAsync();

            return CreatedAtAction("GetMatchLog", new { id = matchLog.MatchId }, matchLog);
        }

        // DELETE: api/MatchLogs/5
        [HttpDelete("{id}")]
        public async Task<IActionResult> DeleteMatchLog(int id)
        {
            var matchLog = await _context.MatchLogs.FindAsync(id);
            if (matchLog == null)
            {
                return NotFound();
            }

            _context.MatchLogs.Remove(matchLog);
            await _context.SaveChangesAsync();

            return NoContent();
        }

        private bool MatchLogExists(int id)
        {
            return _context.MatchLogs.Any(e => e.MatchId == id);
        }
    }
}