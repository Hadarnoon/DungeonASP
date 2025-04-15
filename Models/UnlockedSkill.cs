using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using Microsoft.EntityFrameworkCore;

namespace dungeonMaster_final.Models;

public partial class UnlockedSkill
{
    [Key]
    [Column("UnlockedSkillID")]
    public int UnlockedSkillId { get; set; }

    [Column("PlayerID")]
    public int PlayerId { get; set; }

    public int? Skill { get; set; }

    [Column(TypeName = "datetime")]
    public DateTime UnlockDate { get; set; }

    [ForeignKey("PlayerId")]
    [InverseProperty("UnlockedSkills")]
    public virtual Player? Player { get; set; } = null!;
}
